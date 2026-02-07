<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(AddressRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->addresses()->count() >= 5) {
            return redirect()
                ->to(route('profile.edit').'#addresses')
                ->withErrors(['address_limit' => 'You can add up to 5 addresses only.'], 'address')
                ->withInput();
        }

        $data = $request->validated();
        $data['is_default'] = $data['is_default'] || $user->addresses()->doesntExist();

        if ($data['is_default']) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create($data);

        return redirect()->to(route('profile.edit').'#addresses')->with('status', 'Address added successfully.');
    }

    public function update(AddressRequest $request, Address $address): RedirectResponse
    {
        $this->assertOwnership($address, $request);

        $data = $request->validated();

        if ($data['is_default']) {
            $request->user()
                ->addresses()
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        } else {
            $data['is_default'] = $address->is_default;
        }

        $address->update($data);

        return redirect()->to(route('profile.edit').'#addresses')->with('status', 'Address updated successfully.');
    }

    public function destroy(Address $address, Request $request): RedirectResponse
    {
        $this->assertOwnership($address, $request);

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $nextAddress = $request->user()->addresses()->latest()->first();
            if ($nextAddress) {
                $nextAddress->update(['is_default' => true]);
            }
        }

        return redirect()->to(route('profile.edit').'#addresses')->with('status', 'Address deleted successfully.');
    }

    private function assertOwnership(Address $address, Request $request): void
    {
        abort_if($address->user_id !== $request->user()->id, 404);
    }
}
