import React from 'react';
import { createRoot } from 'react-dom/client';
import { SignInPage } from './Login/SignInPage';

const rootElement = document.getElementById('react-login-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<SignInPage />);
}
