@extends('layouts.admin')

@section('title', 'Settings')
@section('heading', 'Settings')

@section('content')
<div class="max-w-3xl space-y-4">
    <div>
        <h1 class="font-display text-2xl font-bold tracking-tight">Settings</h1>
        <p class="text-sm text-[var(--mist)] mt-1">Studio-wide configuration</p>
    </div>

    <form
        method="POST"
        action="{{ route('admin.settings.update') }}"
        class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-5 space-y-5"
    >
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="admin-label" for="site_name">Site name</label>
                <input id="site_name" name="site_name" type="text" class="admin-input" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required>
            </div>

            <div>
                <label class="admin-label" for="tagline">Tagline</label>
                <input id="tagline" name="tagline" type="text" class="admin-input" value="{{ old('tagline', $settings['tagline'] ?? '') }}">
            </div>

            <div>
                <label class="admin-label" for="contact_email">Contact email</label>
                <input id="contact_email" name="contact_email" type="email" class="admin-input" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
            </div>

            <div>
                <label class="admin-label" for="contact_phone">Contact phone</label>
                <input id="contact_phone" name="contact_phone" type="text" class="admin-input" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="address">Address</label>
                <input id="address" name="address" type="text" class="admin-input" value="{{ old('address', $settings['address'] ?? '') }}">
            </div>

            <div>
                <label class="admin-label" for="instagram">Instagram</label>
                <input id="instagram" name="instagram" type="text" class="admin-input" value="{{ old('instagram', $settings['instagram'] ?? '') }}" placeholder="@yuelistudio or URL">
            </div>

            <div>
                <label class="admin-label" for="currency">Currency</label>
                <input id="currency" name="currency" type="text" class="admin-input" value="{{ old('currency', $settings['currency'] ?? '') }}" placeholder="USD">
            </div>

            <div>
                <label class="admin-label" for="shipping_fee">Shipping fee</label>
                <input id="shipping_fee" name="shipping_fee" type="number" step="0.01" min="0" class="admin-input" value="{{ old('shipping_fee', $settings['shipping_fee'] ?? '') }}">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="about_short">About (short)</label>
                <textarea id="about_short" name="about_short" rows="4" class="admin-input">{{ old('about_short', $settings['about_short'] ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 pt-2 border-t border-[var(--edge)]">
            <button type="submit" class="admin-btn">Save settings</button>
        </div>
    </form>
</div>
@endsection
