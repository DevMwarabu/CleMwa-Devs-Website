import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { LayoutDashboard, Users, FolderKanban, Briefcase, Settings, LogOut, Menu, X } from 'lucide-react';
import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs) {
  return twMerge(clsx(inputs));
}

export default function AdminLayout({ children }) {
    const user = usePage().props.auth.user;
    const [sidebarOpen, setSidebarOpen] = useState(false);

    const navigation = [
        { name: 'Dashboard', href: route('dashboard'), icon: LayoutDashboard, current: route().current('dashboard') },
        { name: 'Leads', href: '#', icon: Users, current: false },
        { name: 'Projects', href: '#', icon: FolderKanban, current: false },
        { name: 'Services', href: '#', icon: Briefcase, current: false },
        { name: 'Settings', href: '#', icon: Settings, current: false },
    ];

    return (
        <div className="flex h-screen bg-gray-50/50 dark:bg-gray-900">
            {/* Mobile sidebar backdrop */}
            {sidebarOpen && (
                <div 
                    className="fixed inset-0 z-40 bg-gray-900/80 backdrop-blur-sm lg:hidden transition-opacity" 
                    onClick={() => setSidebarOpen(false)}
                />
            )}

            {/* Sidebar */}
            <aside 
                className={cn(
                    "fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-gray-950 border-r border-gray-200 dark:border-gray-800 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col",
                    sidebarOpen ? "translate-x-0" : "-translate-x-full"
                )}
            >
                {/* Logo Area */}
                <div className="flex items-center justify-between h-20 px-6 border-b border-gray-100 dark:border-gray-800/60">
                    <Link href="/" className="flex items-center gap-3 group">
                        <div className="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                            C
                        </div>
                        <span className="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400 tracking-tight">
                            CleMwa Devs
                        </span>
                    </Link>
                    <button onClick={() => setSidebarOpen(false)} className="lg:hidden p-2 text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <X className="w-5 h-5" />
                    </button>
                </div>

                {/* Navigation */}
                <nav className="flex-1 px-4 py-6 overflow-y-auto space-y-1.5">
                    {navigation.map((item) => (
                        <Link
                            key={item.name}
                            href={item.href}
                            className={cn(
                                "flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 group relative overflow-hidden",
                                item.current 
                                    ? "text-indigo-600 bg-indigo-50/50 dark:text-indigo-400 dark:bg-indigo-500/10" 
                                    : "text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-white dark:hover:bg-white/5"
                            )}
                        >
                            {item.current && (
                                <span className="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-indigo-600 dark:bg-indigo-500 rounded-r-full" />
                            )}
                            <item.icon className={cn(
                                "w-5 h-5 transition-colors",
                                item.current ? "text-indigo-600 dark:text-indigo-400" : "text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300"
                            )} />
                            {item.name}
                        </Link>
                    ))}
                </nav>

                {/* User Area */}
                <div className="p-4 border-t border-gray-100 dark:border-gray-800/60">
                    <div className="flex items-center gap-3 px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800">
                        <div className="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold border border-indigo-200 dark:border-indigo-800/50">
                            {user.name.charAt(0)}
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {user.name}
                            </p>
                            <p className="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {user.email}
                            </p>
                        </div>
                        <Link
                            href={route('logout')}
                            method="post"
                            as="button"
                            className="p-2 text-gray-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-500/10"
                            title="Log Out"
                        >
                            <LogOut className="w-4 h-4" />
                        </Link>
                    </div>
                </div>
            </aside>

            {/* Main Content */}
            <main className="flex-1 flex flex-col min-w-0 overflow-hidden">
                {/* Header */}
                <header className="h-20 flex items-center justify-between px-6 lg:px-10 bg-white/50 dark:bg-gray-900/50 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-800/50 sticky top-0 z-30">
                    <div className="flex items-center gap-4">
                        <button 
                            onClick={() => setSidebarOpen(true)}
                            className="lg:hidden p-2 -ml-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                        >
                            <Menu className="w-6 h-6" />
                        </button>
                    </div>
                </header>

                {/* Page Content */}
                <div className="flex-1 overflow-y-auto">
                    <div className="p-6 lg:p-10 max-w-7xl mx-auto">
                        {children}
                    </div>
                </div>
            </main>
        </div>
    );
}
