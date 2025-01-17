import './module/sw-product/page/sw-product-detail';
import './module/sw-product/view/sw-product-detail-bundle';

Shopware.Module.register('sw-product-detail-bundle-tab', {
    routeMiddleware(next, currentRoute) {
        const customRouteName = 'sw.product.detail.bundle';

        if (
            currentRoute.name === 'sw.product.detail'
            && currentRoute.children.every((currentRoute) => currentRoute.name !== customRouteName)
        ) {
            currentRoute.children.push({
                name: customRouteName,
                path: '/sw/product/detail/:id/bundle',
                component: 'sw-product-detail-bundle',
                meta: {
                    parentPath: 'sw.product.index'
                }
            });
        }
        next(currentRoute);
    }
});