@extends('layout')


@section('content')
    <x-card class="p-10">
        @if (count($listings) != 0)
            <header>
                <h1 class="text-3xl text-center font-bold my-6 uppercase">
                    Manage Gigs
                </h1>
            </header>
        @endif

        <table class="w-full table-auto rounded-sm">
            <tbody>
                @unless($listings->isEmpty())
                    @foreach ($listings as $listing)
                        <tr class="border-gray-300">
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/listings/{{ $listing->id }}">
                                    {{ $listing->title }}
                                </a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/listings/{{ $listing->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl"><i
                                        class="fa-solid fa-pen-to-square"></i>
                                    Edit</a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form method="POST" action="/listings/{{ $listing->id }}/delete">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">
                                        <i class="fa-solid fa-trash-can"></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <h3 class="text-center font-bold text-3xl">No Gig Found, Please Create the Gig</h3>
                @endunless

            </tbody>
        </table>
    </x-card>
@endsection
