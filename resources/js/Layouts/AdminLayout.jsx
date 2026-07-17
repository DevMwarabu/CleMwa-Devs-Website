import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import {
    LayoutDashboard, Users, FolderKanban, Briefcase,
    FileText, MessageSquare, Settings, LogOut,
    Menu, X, ChevronRight
} from 'lucide-react';

function cn(...classes) {
    return classes.filter(Boolean).join(' ');
}

const NAV = [
    { name: 'Dashboard',    href: '/dashboard',  icon: LayoutDashboard },
    { name: 'Leads',        href: '/admin/leads', icon: Users           },
    { name: 'Projects',     href: '/admin/projects', icon: FolderKanban },
    { name: 'Services',     href: '/admin/services', icon: Briefcase    },
    { name: 'Blog Posts',   href: '/admin/posts', icon: FileText        },
    { name: 'Testimonials', href: '/admin/testimonials', icon: MessageSquare },
];

export default function AdminLayout({ children }) {
    const user = usePage().props.auth.user;
    const [open, setOpen] = useState(false);

    const currentPath = window.location.pathname;

    return (
        <div className="flex h-screen overflow-hidden bg-gray-50 dark:bg-[#0f0f10]">
            {/* ── Backdrop (mobile) ── */}
            {open && (
                <div
                    onClick={() => setOpen(false)}
                    className="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden"
                />
            )}

            {/* ── Sidebar ── */}
            <aside className={cn(
                'fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-white dark:bg-gray-950',
                'border-r border-gray-100 dark:border-gray-800/60',
                'transition-transform duration-300 ease-in-out lg:static lg:translate-x-0',
                open ? 'translate-x-0' : '-translate-x-full'
            )}>
                {/* Logo */}
                <div className="flex items-center justify-between h-16 px-5 border-b border-gray-100 dark:border-gray-800/60 flex-shrink-0">
                    <Link href="/" className="flex items-center gap-2.5 group">
                        <div className="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-indigo-500/30 group-hover:scale-105 transition-transform">
                            C
                        </div>
                        <span className="font-bold text-gray-900 dark:text-white text-sm">
                            CleMwa CMS
                        </span>
                    </Link>
                    <button
                        onClick={() => setOpen(false)}
                        className="lg:hidden p-1.5 rounded-lg text-gray-400 hover:text-gray-900 hover:bg-gray-100 dark:hover:text-white dark:hover:bg-gray-800 transition-colors"
                    >
                        <X className="w-4 h-4" />
                    </button>
                </div>

                {/* Navigation */}
                <nav className="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
                    {NAV.map((item) => {
                        const active = currentPath === item.href || currentPath.startsWith(item.href + '/');
                        return (
                            <Link
                                key={item.name}
                                href={item.href}
                                className={cn(
                                    'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150',
                                    active
                                        ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400'
                                        : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white'
                                )}
                            >
                                <item.icon className={cn(
                                    'w-4.5 h-4.5 flex-shrink-0 transition-colors',
                                    active ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300'
                                )} style={{ width: '1.125rem', height: '1.125rem' }} />
                                {item.name}
                                {active && <ChevronRight className="w-3.5 h-3.5 ml-auto text-indigo-400" />}
                            </Link>
                        );
                    })}
                </nav>

                {/* Bottom: user + settings */}
                <div className="p-3 border-t border-gray-100 dark:border-gray-800/60 flex-shrink-0 space-y-1">
                    <Link
                        href="/profile"
                        className="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white transition-colors"
                    >
                        <Settings className="w-4 h-4 flex-shrink-0 text-gray-400" />
                        Settings
                    </Link>
                    <div className="flex items-center gap-3 px-3 py-2 rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                        <div className="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/50 border border-indigo-200 dark:border-indigo-800 flex items-center justify-center text-indigo-700 dark:text-indigo-300 text-xs font-bold flex-shrink-0">
                            {user.name.charAt(0).toUpperCase()}
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-xs font-semibold text-gray-900 dark:text-white truncate">{user.name}</p>
                            <p className="text-[11px] text-gray-400 dark:text-gray-500 truncate">{user.email}</p>
                        </div>
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            className="p-1.5 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors flex-shrink-0"
                            title="Log out"
                        >
                            <LogOut className="w-3.5 h-3.5" />
                        </Link>
                    </div>
                </div>
            </aside>

            {/* ── Main ── */}
            <div className="flex-1 flex flex-col min-w-0 overflow-hidden">
                {/* Top bar */}
                <header className="h-16 flex items-center gap-4 px-5 lg:px-8 bg-white/70 dark:bg-gray-950/70 backdrop-blur-md border-b border-gray-100 dark:border-gray-800/60 flex-shrink-0 sticky top-0 z-30">
                    <button
                        onClick={() => setOpen(true)}
                        className="lg:hidden p-2 -ml-1 rounded-lg text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                    >
                        <Menu className="w-5 h-5" />
                    </button>
                    {/* Breadcrumb / page title slot — filled by page if needed */}
                    <div className="flex-1" />
                </header>

                {/* Scrollable content */}
                <main className="flex-1 overflow-y-auto">
                    <div className="max-w-7xl mx-auto px-5 lg:px-8 py-8">
                        {children}
                    </div>
                </main>
            </div>
        </div>
    );
}
