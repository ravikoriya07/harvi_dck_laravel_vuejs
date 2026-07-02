/**
 * Ensure page-specific Elementor CSS is present after Inertia client navigations.
 * Initial visit loads sync bundles from app.blade.php; SPA visits must wait for
 * stylesheets to finish loading before theme layout/animation hooks run.
 */
const PAGE_STYLES = {
    Home: ['elementor-generated.css'],
    About: ['about-elementor-generated.css'],
    Services: ['services-elementor-generated.css'],
    Projects: ['projects-elementor-generated.css'],
    ProjectDetail: ['projects-elementor-generated.css'],
    SocialValues: ['projects-elementor-generated.css'],
    SocialValueDetail: ['projects-elementor-generated.css'],
    Blog: ['blog-elementor-generated.css', 'blog-detail-elementor-generated.css'],
    BlogDetail: ['blog-elementor-generated.css', 'blog-detail-elementor-generated.css'],
    Contact: ['contact-elementor-generated.css'],
};

const loaded = new Set();

function loadStylesheet(href) {
    if (loaded.has(href)) {
        return Promise.resolve();
    }

    const existing = document.querySelector(`link[rel="stylesheet"][href="${href}"]`);

    if (existing) {
        if (existing.sheet) {
            loaded.add(href);

            return Promise.resolve();
        }

        return new Promise((resolve) => {
            existing.addEventListener('load', () => {
                loaded.add(href);
                resolve();
            }, { once: true });
            existing.addEventListener('error', () => {
                loaded.add(href);
                resolve();
            }, { once: true });
        });
    }

    return new Promise((resolve) => {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        link.onload = () => {
            loaded.add(href);
            resolve();
        };
        link.onerror = () => {
            loaded.add(href);
            resolve();
        };
        document.head.appendChild(link);
    });
}

export function ensurePageStyles(componentName) {
    const files = PAGE_STYLES[componentName];

    if (!files?.length) {
        return Promise.resolve();
    }

    return Promise.all(files.map((file) => {
        const version = window.__cssVersion;
        const href = version
            ? `/assets/css/${file}?v=${version}`
            : `/assets/css/${file}`;

        return loadStylesheet(href);
    }));
}

export function preloadPageImage(href, media) {
    if (!href || document.querySelector(`link[rel="preload"][href="${href}"]`)) {
        return;
    }

    const link = document.createElement('link');
    link.rel = 'preload';
    link.as = 'image';
    link.href = href;
    if (media) {
        link.media = media;
    }
    link.fetchPriority = 'high';
    document.head.appendChild(link);
}
