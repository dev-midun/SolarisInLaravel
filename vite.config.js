import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { glob } from 'glob';

function GetFilesArray(query) {
    return glob.sync(query);
}

const scssFiles = GetFilesArray('resources/css/pages/**/*.scss');
const cssFiles = GetFilesArray('resources/css/pages/**/*.css');
const jsFiles = GetFilesArray('resources/js/pages/**/*.js');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                ...scssFiles,
                ...cssFiles, 
                'resources/js/app.js',
                'resources/js/main.js',
                ...jsFiles
            ],
            refresh: true,
        })
    ],
});