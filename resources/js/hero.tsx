import React from 'react';
import { createRoot } from 'react-dom/client';
import { CanvasRevealEffect } from './Components/HeroBackground';
import MacbookScrollDemo from './Components/MacbookScrollDemo';

const rootElement = document.getElementById('react-hero-background');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(
        <div className="relative w-full h-full min-h-screen">
            <div className="fixed inset-0 w-full h-full z-0">
                <CanvasRevealEffect
                    animationSpeed={3}
                    containerClassName="bg-black"
                    colors={[
                        [14, 165, 233], // Sky blue
                        [139, 92, 246], // Violet
                    ]}
                    dotSize={4}
                    reverse={false}
                    showGradient={false}
                />
            </div>
            
            {/* Smooth gradient blend into the section below */}
            <div className="fixed inset-x-0 bottom-0 h-[20vh] bg-gradient-to-t from-black to-transparent z-0 pointer-events-none" />
            <div className="fixed inset-x-0 top-0 h-[10vh] bg-gradient-to-b from-black to-transparent z-0 pointer-events-none" />
            
            <div className="relative z-10 w-full">
               <MacbookScrollDemo />
            </div>
        </div>
    );
}
