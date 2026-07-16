<x-layouts.app>
    <div class="relative pt-32 pb-20 min-h-screen bg-[#050507]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Request a Quote</h1>
                <p class="text-xl text-slate-400">Select a project type below to get a detailed estimate for your enterprise requirements.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($quoteProjects as $project)
                <div class="glass overflow-hidden rounded-2xl hover:-translate-y-2 hover:bg-white/5 transition-all duration-300 group border border-white/10 backdrop-blur-md">
                    <div class="h-48 w-full bg-gradient-to-br from-{{ $project->color_theme }}-500/20 to-{{ $project->color_theme == 'sky' ? 'indigo' : 'fuchsia' }}-600/20 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-[url('{{ $project->image_url }}')] bg-cover bg-center opacity-40 mix-blend-overlay group-hover:scale-110 transition-transform duration-700"></div>
                        <h4 class="text-2xl font-bold text-white z-10 drop-shadow-lg opacity-80 group-hover:opacity-100 transition-opacity">{{ $project->subtitle }}</h4>
                    </div>
                    <div class="p-8 flex flex-col h-[calc(100%-12rem)]">
                        <h3 class="text-xl font-bold text-white mb-4">{{ $project->title }}</h3>
                        <p class="text-slate-400 mb-8 flex-grow">{{ $project->description }}</p>
                        
                        <a href="/contact?subject={{ Str::slug($project->subtitle) }}" class="w-full inline-flex justify-center items-center px-6 py-4 bg-{{ $project->color_theme }}-500 hover:bg-{{ $project->color_theme }}-400 text-white font-bold rounded-xl transition-all shadow-lg shadow-{{ $project->color_theme }}-500/25 hover:shadow-{{ $project->color_theme }}-500/40">
                            Get Estimate
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-slate-400 text-lg">No projects currently require a quote.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
