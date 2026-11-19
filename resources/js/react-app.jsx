import React from 'react';
import { createRoot } from 'react-dom/client';

// Import component from components folder
import HelloReact from './components/HelloReact';
import '../css/react-custom.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap/dist/css/bootstrap.min.css';



console.log('React entry file loaded!');

const rootElement = document.getElementById('react-root');

if (rootElement) {
    createRoot(rootElement).render(
        <React.StrictMode>
            <HelloReact />
        </React.StrictMode>
    );
} else {
    console.error('React root element not found!');
}