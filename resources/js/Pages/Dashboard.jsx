import AdminLayout from '@/Layouts/AdminLayout';
import { Head } from '@inertiajs/react';
import {
    Users, FolderKanban, Briefcase, FileText,
    MessageSquare, TrendingUp, ArrowUpRight, ArrowDownRight,
    Clock, CheckCircle2, AlertCircle
} from 'lucide-react';
import {
    AreaChart, Area, XAxis, YAxis, CartesianGrid,
    Tooltip, ResponsiveContainer, BarChart, Bar, Cell
} from 'recharts';

const COLORS = ['#6366f1', '#8b5cf6', '#ec4899', '#14b8a6'];

const STATUS_STYLES = {
    new:         'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
    contacted:   'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400',
    qualified:   'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
    closed:      'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
};

export default function Dashboard({ stats, recentLeads }) {
    // Simulated 7-month trend (last value = this month's real stat)
    const trendData = [
        { month: 'Jan', leads: 3, projects: 1 },
        { month: 'Feb', leads: 6, projects: 2 },
        { month: 'Mar', leads: 4, projects: 1 },
        { month: 'Apr', leads: 9, projects: 3 },
        { month: 'May', leads: 14, projects: 2 },
        { month: 'Jun', leads: 18, projects: 4 },
        { month: 'Jul', leads: stats.leads_this_month, projects: stats.total_projects },
    ];

    const barData = [
        { name: 'Projects', value: stats.total_projects,  color: COLORS[0] },
        { name: 'Services', value: stats.total_services,  color: COLORS[1] },
        { name: 'Posts',    value: stats.published_posts, color: COLORS[2] },
        { name: 'Pending',  value: stats.pending_testimonials, color: COLORS[3] },
    ];

    const statCards = [
        {
            label: 'Leads This Month',
            value: stats.leads_this_month,
            icon: TrendingUp,
            delta: '+12%',
            up: true,
            accent: 'from-indigo-500 to-purple-600',
            light: 'bg-indigo-50 dark:bg-indigo-500/10',
            text: 'text-indigo-600 dark:text-indigo-400',
        },
        {
            label: 'Total Projects',
            value: stats.total_projects,
            icon: FolderKanban,
            delta: 'All time',
            up: true,
            accent: 'from-purple-500 to-pink-600',
            light: 'bg-purple-50 dark:bg-purple-500/10',
            text: 'text-purple-600 dark:text-purple-400',
        },
        {
            label: 'Active Services',
            value: stats.total_services,
            icon: Briefcase,
            delta: 'Stable',
            up: true,
            accent: 'from-emerald-500 to-teal-600',
            light: 'bg-emerald-50 dark:bg-emerald-500/10',
            text: 'text-emerald-600 dark:text-emerald-400',
        },
        {
            label: 'Published Posts',
            value: stats.published_posts,
            icon: FileText,
            delta: 'All time',
            up: true,
            accent: 'from-sky-500 to-cyan-600',
            light: 'bg-sky-50 dark:bg-sky-500/10',
            text: 'text-sky-600 dark:text-sky-400',
        },
    ];

    const CustomTooltip = ({ active, payload, label }) => {
        if (active && payload && payload.length) {
            return (
                <div className="bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 shadow-xl text-sm">
                    <p className="text-gray-400 mb-1">{label}</p>
                    {payload.map((p, i) => (
                        <p key={i} className="font-semibold" style={{ color: p.color }}>
                            {p.name}: {p.value}
                        </p>
                    ))}
                </div>
            );
        }
        return null;
    };

    return (
        <AdminLayout>
            <Head title="Dashboard" />

            <div className="space-y-8">
                {/* Page heading */}
                <div>
                    <h1 className="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                        Overview
                    </h1>
                    <p className="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Here's what's happening with your site today.
                    </p>
                </div>

                {/* Stat cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                    {statCards.map((card) => (
                        <div
                            key={card.label}
                            className="bg-white dark:bg-gray-900 rounded-2xl p-5 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow"
                        >
                            <div className="flex items-center justify-between mb-4">
                                <div className={`w-10 h-10 rounded-xl ${card.light} flex items-center justify-center`}>
                                    <card.icon className={`w-5 h-5 ${card.text}`} />
                                </div>
                                <span className={`flex items-center gap-0.5 text-xs font-medium ${card.up ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'}`}>
                                    {card.up ? <ArrowUpRight className="w-3.5 h-3.5" /> : <ArrowDownRight className="w-3.5 h-3.5" />}
                                    {card.delta}
                                </span>
                            </div>
                            <p className="text-3xl font-bold text-gray-900 dark:text-white">{card.value}</p>
                            <p className="mt-1 text-sm text-gray-500 dark:text-gray-400">{card.label}</p>
                        </div>
                    ))}
                </div>

                {/* Charts row */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    {/* Area chart */}
                    <div className="lg:col-span-2 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                        <div className="mb-6">
                            <h2 className="font-semibold text-gray-900 dark:text-white">Lead Trend</h2>
                            <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Monthly inquiries over the past 7 months</p>
                        </div>
                        <div className="h-60">
                            <ResponsiveContainer width="100%" height="100%">
                                <AreaChart data={trendData} margin={{ top: 4, right: 4, left: -24, bottom: 0 }}>
                                    <defs>
                                        <linearGradient id="gLeads" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="5%"  stopColor="#6366f1" stopOpacity={0.25} />
                                            <stop offset="95%" stopColor="#6366f1" stopOpacity={0} />
                                        </linearGradient>
                                    </defs>
                                    <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#e5e7eb" className="dark:stroke-gray-800" />
                                    <XAxis dataKey="month" axisLine={false} tickLine={false} tick={{ fill: '#9ca3af', fontSize: 12 }} dy={8} />
                                    <YAxis axisLine={false} tickLine={false} tick={{ fill: '#9ca3af', fontSize: 12 }} allowDecimals={false} />
                                    <Tooltip content={<CustomTooltip />} />
                                    <Area type="monotone" dataKey="leads" name="Leads" stroke="#6366f1" strokeWidth={2.5} fill="url(#gLeads)" dot={false} activeDot={{ r: 5, fill: '#6366f1', strokeWidth: 2, stroke: '#fff' }} />
                                </AreaChart>
                            </ResponsiveContainer>
                        </div>
                    </div>

                    {/* Bar chart */}
                    <div className="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                        <div className="mb-6">
                            <h2 className="font-semibold text-gray-900 dark:text-white">Content Summary</h2>
                            <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Current totals by category</p>
                        </div>
                        <div className="h-60">
                            <ResponsiveContainer width="100%" height="100%">
                                <BarChart data={barData} margin={{ top: 4, right: 4, left: -24, bottom: 0 }} barSize={28}>
                                    <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#e5e7eb" className="dark:stroke-gray-800" />
                                    <XAxis dataKey="name" axisLine={false} tickLine={false} tick={{ fill: '#9ca3af', fontSize: 12 }} dy={8} />
                                    <YAxis axisLine={false} tickLine={false} tick={{ fill: '#9ca3af', fontSize: 12 }} allowDecimals={false} />
                                    <Tooltip content={<CustomTooltip />} />
                                    <Bar dataKey="value" name="Count" radius={[6, 6, 0, 0]}>
                                        {barData.map((entry, index) => (
                                            <Cell key={index} fill={entry.color} />
                                        ))}
                                    </Bar>
                                </BarChart>
                            </ResponsiveContainer>
                        </div>
                    </div>
                </div>

                {/* Recent Leads table */}
                <div className="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div className="flex items-center justify-between px-6 py-5 border-b border-gray-100 dark:border-gray-800">
                        <div>
                            <h2 className="font-semibold text-gray-900 dark:text-white">Recent Inquiries</h2>
                            <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Latest leads received</p>
                        </div>
                        <span className="text-xs font-medium text-indigo-600 dark:text-indigo-400 cursor-pointer hover:underline">
                            View all
                        </span>
                    </div>

                    {recentLeads.length === 0 ? (
                        <div className="flex flex-col items-center justify-center py-16 text-center">
                            <MessageSquare className="w-10 h-10 text-gray-300 dark:text-gray-600 mb-3" />
                            <p className="text-sm font-medium text-gray-500 dark:text-gray-400">No inquiries yet</p>
                            <p className="text-xs text-gray-400 dark:text-gray-500 mt-1">Leads from your contact form will appear here.</p>
                        </div>
                    ) : (
                        <div className="divide-y divide-gray-50 dark:divide-gray-800">
                            {recentLeads.map((lead) => (
                                <div key={lead.id} className="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                                    {/* Avatar */}
                                    <div className="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                        {lead.name?.charAt(0).toUpperCase() ?? '?'}
                                    </div>

                                    {/* Info */}
                                    <div className="flex-1 min-w-0">
                                        <p className="text-sm font-medium text-gray-900 dark:text-white truncate">{lead.name}</p>
                                        <p className="text-xs text-gray-500 dark:text-gray-400 truncate">{lead.email}</p>
                                    </div>

                                    {/* Subject */}
                                    <p className="hidden sm:block text-xs text-gray-500 dark:text-gray-400 truncate max-w-[180px]">
                                        {lead.subject ?? lead.message ?? '—'}
                                    </p>

                                    {/* Status badge */}
                                    <span className={`hidden md:inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium ${STATUS_STYLES[lead.status] ?? STATUS_STYLES.new}`}>
                                        {lead.status === 'new'       && <Clock className="w-3 h-3" />}
                                        {lead.status === 'contacted' && <AlertCircle className="w-3 h-3" />}
                                        {lead.status === 'qualified' && <CheckCircle2 className="w-3 h-3" />}
                                        {lead.status ?? 'new'}
                                    </span>

                                    {/* Date */}
                                    <p className="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap flex-shrink-0">
                                        {new Date(lead.created_at).toLocaleDateString('en-GB', { day: 'numeric', month: 'short' })}
                                    </p>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AdminLayout>
    );
}
