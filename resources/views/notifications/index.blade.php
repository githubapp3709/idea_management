@extends('layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')

<div class="max-w-4xl mx-auto space-y-4">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold">
            All Notifications
        </h2>

        @if(auth()->user()->unreadNotifications->count())
            <form method="POST" action="{{ route('notifications.readAll') }}">
                @csrf
                <button class="text-sm text-indigo-600 hover:underline">
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    {{-- Notification List --}}
    <div class="bg-white rounded shadow divide-y">

        @forelse($notifications as $notification)

            <div class="p-4 flex justify-between items-start
                {{ is_null($notification->read_at) ? 'bg-indigo-50' : '' }}">

                <div>
                    <p class="text-sm text-gray-800">
                        {{ $notification->data['message'] ?? 'Notification' }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>

                @if(is_null($notification->read_at))
                    <form method="POST"
                          action="{{ route('notifications.read', $notification->id) }}">
                        @csrf
                        <button class="text-xs text-indigo-600 hover:underline">
                            Mark as read
                        </button>
                    </form>
                @endif

            </div>

        @empty
            <div class="p-6 text-center text-gray-500">
                No notifications yet
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    <div>
        {{ $notifications->links() }}
    </div>

</div>

@endsection
