<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>POS Terminal - {{ config('app.name') }}</title>
        <style>
            /* Hide scrollbars but keep functionality */
            ::-webkit-scrollbar {
                width: 4px;
                height: 4px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: #374151;
                border-radius: 2px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #4B5563;
            }
        </style>
    </head>
    <body class="min-h-screen bg-zinc-100 dark:bg-zinc-900 overflow-hidden">
        <!-- POS Header -->
        <div class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <x-app-logo class="h-8 w-auto" />
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">POS Terminal</span>
                        <span class="px-2 py-1 text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">Active</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-zinc-600 dark:text-zinc-400">
                        <span>{{ auth()->user()->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ now()->format('M j, Y g:i A') }}</span>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <flux:button size="sm" variant="ghost" onclick="window.close()">
                            Close
                        </flux:button>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:button size="sm" variant="ghost" type="submit">
                                Logout
                            </flux:button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- POS Content -->
        <div class="h-[calc(100vh-60px)] overflow-hidden">
            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>