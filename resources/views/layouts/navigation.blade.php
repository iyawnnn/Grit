<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-10 bg-black/50 md:hidden" @click="sidebarOpen = false" x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-20 w-60 bg-white border-r border-gray-200 transition-transform duration-200 ease-in-out md:translate-x-0 md:static flex flex-col pt-4">
    
    <nav class="flex-1 px-3 space-y-1">
        
        <p class="px-3 text-xs font-semibold tracking-wider text-gray-400 uppercase mb-3 mt-2">Menu</p>

        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors group {{ request()->routeIs('dashboard') ? 'bg-black text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-black' }}">
            <svg class="w-4 h-4 mr-3 transition-colors {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-black' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('applications.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors group {{ request()->routeIs('applications.index', 'applications.create', 'applications.show', 'applications.edit') ? 'bg-black text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-black' }}">
            <svg class="w-4 h-4 mr-3 transition-colors {{ request()->routeIs('applications.index', 'applications.create', 'applications.show', 'applications.edit') ? 'text-white' : 'text-gray-400 group-hover:text-black' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
            </svg>
            Applications
        </a>

        <a href="{{ route('resumes.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors group {{ request()->routeIs('resumes.*') ? 'bg-black text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-black' }}">
            <svg class="w-4 h-4 mr-3 transition-colors {{ request()->routeIs('resumes.*') ? 'text-white' : 'text-gray-400 group-hover:text-black' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            Resumes
        </a>

        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold tracking-wider text-gray-400 uppercase mb-3">Analysis & Tracking</p>
        </div>

        <a href="{{ route('matches.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors group {{ request()->routeIs('matches.*') ? 'bg-black text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-black' }}">
            <svg class="w-4 h-4 mr-3 transition-colors {{ request()->routeIs('matches.*') ? 'text-white' : 'text-gray-400 group-hover:text-black' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            Match Reports
        </a>

        <a href="{{ route('applications.board') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors group {{ request()->routeIs('applications.board') ? 'bg-black text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-black' }}">
            <svg class="w-4 h-4 mr-3 transition-colors {{ request()->routeIs('applications.board') ? 'text-white' : 'text-gray-400 group-hover:text-black' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.5-6h15m-15-6h15m-3-4.5h3c.621 0 1.125.504 1.125 1.125v18.75c0 .621-.504 1.125-1.125 1.125h-3c-.621 0-1.125-.504-1.125-1.125V5.625c0-.621.504-1.125 1.125-1.125z" />
            </svg>
            Job Board
        </a>

    </nav>
</aside>