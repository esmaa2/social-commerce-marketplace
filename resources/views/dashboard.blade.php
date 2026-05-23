@extends('layouts.base')

@section('main_content')

<div style="padding: 48px 24px;">
    <div style="max-width: 80rem; margin: 0 auto;">
        <div style="background: #1f2937; border-radius: 0.5rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); overflow: hidden;">
            <div style="padding: 1.5rem; color: #f9fafb;">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #f3f4f6; margin-bottom: 1rem;">
                    {{ __('Dashboard') }}
                </h2>
                <p>{{ __("You're logged in!") }}</p>
            </div>
        </div>
    </div>
</div>
@endsection