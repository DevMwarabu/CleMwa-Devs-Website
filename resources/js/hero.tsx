import React from 'react';
import { createRoot } from 'react-dom/client';
import { CanvasRevealEffect } from './Components/HeroBackground';
import MacbookScrollDemo from './Components/MacbookScrollDemo';

const rootElement = document.getElementById('react-hero-background');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(
        <div className="relative w-full h-full min-h-screen bg-black">
            <div className="absolute inset-0 w-full h-full z-0 bg-black"></div>
            
            {/* Smooth gradient blend into the section below */}
            <div className="absolute inset-x-0 bottom-0 h-[20vh] bg-gradient-to-t from-black to-transparent z-0 pointer-events-none" />
            <div className="absolute inset-x-0 top-0 h-[10vh] bg-gradient-to-b from-black to-transparent z-0 pointer-events-none" />
            
            <div className="relative z-10 w-full">
               <MacbookScrollDemo />
            </div>
        </div>
    );
}
