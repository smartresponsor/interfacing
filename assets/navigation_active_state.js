const normalizePath = (value) => {
    try {
        const url = new URL(value, window.location.origin);
        const path = url.pathname === '/' ? '/' : url.pathname.replace(/\/+$/, '');

        return path || '/';
    } catch {
        return null;
    }
};

const pathMatches = (currentPath, candidatePath) => {
    if (candidatePath === '/') {
        return currentPath === '/';
    }

    return currentPath === candidatePath || currentPath.startsWith(`${candidatePath}/`);
};

const refreshNavigationActiveState = () => {
    const currentPath = normalizePath(window.location.href);

    if (currentPath === null) {
        return;
    }

    document.querySelectorAll('[data-interfacing-location-item]').forEach((item) => {
        item.classList.remove('is-active');
        item.removeAttribute('aria-current');
    });

    const matches = [];

    document.querySelectorAll('[data-interfacing-location-item] > .interfacing-location-link[href]').forEach((link) => {
        const candidatePath = normalizePath(link.getAttribute('href'));

        if (candidatePath === null || !pathMatches(currentPath, candidatePath)) {
            return;
        }

        matches.push({
            item: link.closest('[data-interfacing-location-item]'),
            pathLength: candidatePath.length,
        });
    });

    matches
        .sort((left, right) => right.pathLength - left.pathLength)
        .filter((match, _index, all) => match.pathLength === all[0]?.pathLength)
        .forEach(({ item }) => {
            if (!(item instanceof HTMLElement)) {
                return;
            }

            item.classList.add('is-active');
            item.setAttribute('aria-current', 'page');
        });
};

document.addEventListener('turbo:load', refreshNavigationActiveState);
document.addEventListener('turbo:frame-load', refreshNavigationActiveState);
window.addEventListener('popstate', refreshNavigationActiveState);

