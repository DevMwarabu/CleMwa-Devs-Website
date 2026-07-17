import AdminLayout from '@/Layouts/AdminLayout';
import { Head } from '@inertiajs/react';
import { Users, FileText, Briefcase, MessageSquare, ArrowUpRight, ArrowDownRight } from 'lucide-react';
import { AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts';

export default function Dashboard({ stats, recentLeads }) {
    // Mock data for the chart since we don't have historical data generated yet
    const chartData = [
        { name: 'Jan', leads: 4 },
        { name: 'Feb', leads: 7 },
        { name: 'Mar', leads: 5 },
        { name: 'Apr', leads: 10 },
        { name: 'May', leads: 15 },
        { name: 'Jun', leads: 22 },
        { name: 'Jul', leads: stats.leads_this_month },
    ];

    const cards = [
        {
            title: 'Leads This Month',
            value: stats.leads_this_month,
            icon: Users,
            trend: '+12%',
            trendUp: true,
            color: 'text-blue-600 dark:text-blue-400',
            bg: 'bg-blue-50 dark:bg-blue-900/20'
        },
        {
            title: 'Total Projects',
            value: stats.total_projects,
            icon: Briefcase,
            trend: '+3',
            trendUp: true,
            color: 'text-indigo-600 dark:text-indigo-400',
            bg: 'bg-indigo-50 dark:bg-indigo-900/20'
        },
        {
            title: 'Active Services',
            value: stats.total_services,
            icon: FileText,
            trend: 'Stable',
            trendUp: true,
            color: 'text-emerald-600 dark:text-emerald-400',
            bg: 'bg-emerald-50 dark:bg-emerald-900/20'
        },
        {
            title: 'Pending Testimonials',
            value: stats.pending_testimonials,
            icon: MessageSquare,
            trend: '-2',
            trendUp: false,
            color: 'text-rose-600 dark:text-rose-400',
            bg: 'bg-rose-50 dark:bg-rose-900/20'
        }
    ];

    return (
        <AdminLayout>
            <Head title="Dashboard" />

            <div className="space-y-6">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
                    <p className="text-gray-500 dark:text-gray-400 mt-1">Welcome to your CleMwa CMS admin panel.</p>
                </div>

                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {cards.map((card, index) => (
                        <div key={index} className="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
                            <div className="flex items-center justify-between">
                                <div className={`p-3 rounded-xl ${card.bg}`}>
                                    <card.icon className={`w-6 h-6 ${card.color}`} />
                                </div>
                                <div className={`flex items-center gap-1 text-sm font-medium ${card.trendUp ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'}`}>
                                    {card.trend}
                                    {card.trendUp ? <ArrowUpRight className="w-4 h-4" /> : <ArrowDownRight className="w-4 h-4" />}
                                </div>
                            </div>
                            <div className="mt-4">
                                <p className="text-sm font-medium text-gray-500 dark:text-gray-400">{card.title}</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white mt-1">{card.value}</p>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Chart Area */}
                    <div className="lg:col-span-2 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                        <h2 className="text-lg font-bold text-gray-900 dark:text-white mb-6">Lead Generation Trend</h2>
                        <div className="h-[300px] w-full">
                            <ResponsiveContainer width="100%" height="100%">
                                <AreaChart data={chartData} margin={{ top: 10, right: 10, left: -20, bottom: 0 }}>
                                    <defs>
                                        <linearGradient id="colorLeads" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="5%" stopColor="#4f46e5" stopOpacity={0.3}/>
                                            <stop offset="95%" stopColor="#4f46e5" stopOpacity={0}/>
                                        </linearGradient>
                                    </defs>
                                    <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#374151" opacity={0.2} />
                                    <XAxis dataKey="name" axisLine={false} tickLine={false} tick={{fill: '#6b7280', fontSize: 12}} dy={10} />
                                    <YAxis axisLine={false} tickLine={false} tick={{fill: '#6b7280', fontSize: 12}} />
                                    <Tooltip 
                                        contentStyle={{ backgroundColor: '#1f2937', borderColor: '#374151', color: '#f9fafb', borderRadius: '0.5rem' }}
                                        itemStyle={{ color: '#818cf8' }}
                                    />
                                    <Area type="monotone" dataKey="leads" stroke="#4f46e5" strokeWidth={3} fillOpacity={1} fill="url(#colorLeads)" />
                                </AreaChart>
                            </ResponsiveContainer>
                        </div>
                    </div>

                    {/* Recent Leads */}
                    <div className="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                        <div className="flex items-center justify-between mb-6">
                            <h2 className="text-lg font-bold text-gray-900 dark:text-white">Recent Inquiries</h2>
                            <button className="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700">View all</button>
                        </div>
                        <div className="space-y-4">
                            {recentLeads.length > 0 ? recentLeads.map((lead) => (
                                <div key={lead.id} className="flex items-start gap-4 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <div className="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-700 dark:text-indigo-400 font-bold flex-shrink-0">
                                        {lead.name.charAt(0)}
                                    </div>
                                    <div className="flex-1 min-w-0">
                                        <p className="text-sm font-semibold text-gray-900 dark:text-white truncate">{lead.name}</p>
                                        <p className="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">{lead.email}</p>
                                        <p className="text-xs text-gray-400 dark:text-gray-500 mt-1 line-clamp-1">{lead.message}</p>
                                    </div>
                                </div>
                            )) : (
                                <p className="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No recent inquiries found.</p>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
