import React from "react";
import { MacbookScroll } from "./ui/macbook-scroll";

export default function MacbookScrollDemo({ settings }: { settings?: any }) {
  const headline = settings?.hero_headline || "Engineering Digital Excellence.";
  const highlight = settings?.hero_headline_highlight || "CleMwa Developers.";
  const featuredProject = settings?.featured_project;

  return (
    <div className="w-full bg-transparent text-white relative">
      <MacbookScroll
        title={
          <span className="text-white">
            {headline} <br /> <span className="text-accent-400">{highlight}</span>
          </span>
        }
        badge={
          <div className="h-10 w-10 -rotate-12 transform flex items-center justify-center bg-accent-500 rounded-lg">
            <span className="text-white font-bold text-xs">Cle</span>
          </div>
        }
        src={featuredProject?.image_url || `/images/admin_login_bg.png`}
        showGradient={false}
        projectTitle={featuredProject?.title || "Featured Work"}
        projectDescription={featuredProject?.short_description || "See our latest projects in the portfolio."}
      />
    </div>
  );
}
