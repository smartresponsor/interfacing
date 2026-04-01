import React from 'react';
import ReactDOM from 'react-dom/client';
import { ConfigProvider, Card, Typography } from 'antd';
import { PrimeReactProvider } from 'primereact/api';
import 'primeicons/primeicons.css';
import App from './App';

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <PrimeReactProvider>
      <ConfigProvider>
        <App />
      </ConfigProvider>
    </PrimeReactProvider>
  </React.StrictMode>
);
