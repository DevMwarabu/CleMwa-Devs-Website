import React from "react";
import { MacbookScroll } from "./ui/macbook-scroll";

export default function MacbookScrollDemo() {
  return (
    <div className="w-full bg-transparent text-white relative">
      <MacbookScroll
        title={
          <span className="text-white">
            Engineering Digital Excellence. <br /> CleMwa Developers.
          </span>
        }
        badge={
          <div className="h-10 w-10 -rotate-12 transform flex items-center justify-center bg-accent-500 rounded-lg">
            <span className="text-white font-bold text-xs">Cle</span>
          </div>
        }
        src={`/images/admin_login_bg.png`}
        showGradient={false}
        projectTitle="CleMwa POS Cloud"
        projectDescription="An enterprise-grade point of sale ecosystem built for modern retail."
      />
    </div>
  );
}
