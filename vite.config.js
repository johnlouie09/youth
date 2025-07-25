import { fileURLToPath, URL } from 'node:url'
import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'
import tailwindcss from '@tailwindcss/vite'


// https://vitejs.dev/config/
export default ({mode}) => {
  const isProduction = mode === 'production';

  const config = {
    plugins: [
      vue(),
      vueDevTools(),
      tailwindcss(),
    ],
    resolve: {
      alias: {
        '@': fileURLToPath(new URL('./src', import.meta.url))
      }
    },
    base: '/',
    server: {
      host: 'localhost',
      proxy: {
        '/app': {
          target: 'http://localhost/youth',
          changeOrigin: true,
        }
      }
    },
    build: {
      outDir: 'dist'
    }
  };

  return defineConfig(config);
};