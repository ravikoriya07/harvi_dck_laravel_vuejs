/**
 * Ensure page-specific Elementor CSS is present after Inertia client navigations.
 * Initial visit loads sync + async bundles from app.blade.php; this covers fast SPA clicks.
 */
const PAGE_STYLES = {
    Home: ['elementor-generated.css'],
    About: ['about-elementor-generated.css'],
    Services: ['services-elementor-generated.css'],
    Projects: ['projects-elementor-generated.css'],
    ProjectDetail: ['projects-elementor-generated.css'],
    Blog: ['blog-elementor-generated.css', 'blog-detail-elementor-generated.css'],
    BlogDetail: ['blog-elementor-generated.css', 'blog-detail-elementor-generated.css'],
    Contact: ['contact-elementor-generated.css'],
};

const loaded = new Set();

export function ensurePageStyles(componentName) {
    const files = PAGE_STYLES[componentName];

    if (!files) {
        return;
    }

    files.forEach((file) => {
        const href = `/assets/css/${file}`;

        if (loaded.has(href) || document.querySelector(`link[rel="stylesheet"][href="${href}"]`)) {
            loaded.add(href);

            return;
        }

        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        document.head.appendChild(link);
        loaded.add(href);
    });
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
