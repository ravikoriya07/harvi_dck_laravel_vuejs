/**
 * Whether `href` should use Inertia `<Link>` (client visit) instead of a full page load.
 * Same-origin app paths only; hashes, mailto, tel, and external http(s) use a normal `<a>`.
 */
export function isSpaHref(href) {
    if (typeof href !== 'string' || href.length === 0) return false;
    if (href.startsWith('//')) return false;
    return href.startsWith('/');
}
