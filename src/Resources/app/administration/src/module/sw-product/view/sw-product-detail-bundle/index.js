import template from './sw-product-detail-bundle.html.twig';

const { Context, Component, Mixin, Utils } = Shopware;
const { Criteria } = Shopware.Data;
const { mapState } = Shopware.Component.getComponentHelper();

Shopware.Component.register('sw-product-detail-bundle', {
    template,

    inject: ['repositoryFactory'],

    data(){
        return {
            isLoading: true,
            isSaveSuccessful: false,
            selectedProduct: null,
        }
    },

    metaInfo() {
        return {
            title: 'Bundle'
        };
    },

    watch: {
        'product.id': {
            immediate: true,
            handler(newValue) {
                if (!newValue) {
                    return;
                }

                this.loadAssignedBundleProducts();
            },
        },
    },

    computed: {
        ...mapState('swProductDetail', [
            'product',
        ]),

        productRepository() {
            return this.repositoryFactory.create('product');
        },

        bundleProductRepository() {
            return this.repositoryFactory.create('jbl_bundle_product');
        },

        contextWithInheritance() {
            return { ...Shopware.Context.api, inheritance: true };
        },

        bundleProductColumns(){
            return this.getBundleProductColumns();
        },

        productCriteria(){
            const criteria = new Criteria(1, 25);

            criteria.addAssociation('options');
            criteria.addAssociation('options.group');
            criteria.addAssociation('cover');
            criteria.addAssociation('cover.media');
            criteria.addAssociation("bundleProducts");

            criteria.addFilter(Criteria.equals('active', true));
            return criteria;
        },

    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            if(typeof this.product.id !== "undefined"){
                this.loadAssignedBundleProducts();
            }
        },

        async loadAssignedBundleProducts(){
            if (!this.product || !this.product.id) {
                return;
            }

            this.isLoading = true;

            const criteria = new Criteria();
            criteria.addFilter(Criteria.equals("productId", this.product.id));
            criteria.addAssociation("bundleProduct");
            criteria.addAssociation("bundleProduct.cover");
            criteria.addAssociation("bundleProduct.cover.media");
            criteria.addAssociation("bundleProduct.options");
            criteria.addAssociation("bundleProduct.options.group");

            this.product.bundleProducts = await this.bundleProductRepository.search(criteria, this.contextWithInheritance);

            this.isLoading = false;
        },

        getBundleProductColumns(){
            /*width: 'auto',
            allowResize: false,
            sortable: true,
            visible: true,
            align: 'left',
            naturalSorting: false,*/

            return [{
                property: 'bundleProduct.cover',
                dataIndex: 'bundleProduct.cover',
                label: 'Vorschau',
                align: 'center',
                width: '15%'
            },{
                property: 'bundleProduct.name',
                dataIndex: 'bundleProduct.name',
                label: 'Produkt',
                width: '55%'
            },{
                property: 'quantity',
                dataIndex: 'quantity',
                label: 'Anzahl',
                width: '15%'
            },{
                property: 'active',
                dataIndex: 'active',
                label: 'Aktiv',
                width: '15%'
            }];
        },

        isVariant(productEntity) {
            return productEntity.parentId !== null;
        },

        onAddProduct(productId, product){
            const bundleProduct = this.bundleProductRepository.create();
            bundleProduct.quantity = 1;
            bundleProduct.active = true;
            bundleProduct.bundleProductId = productId;
            bundleProduct.bundleProduct = product;
            bundleProduct.productId = this.product.id;

            this.product.bundleProducts.push(bundleProduct);
            this.syncBundleProducts();
        },

        onDeleteBundleProduct(bundleProduct, index){
            this.bundleProductRepository.delete(bundleProduct.id).then(() => {
                //this.createdComponent();
                this.product.bundleProducts.splice(index, 1);
                this.syncBundleProducts();
            });
        },

        onDisableBundleProduct(bundleProduct, index){
            bundleProduct.active = false;
            this.syncBundleProducts();
        },

        onEnableBundleProduct(bundleProduct, index){
            bundleProduct.active = true;
            this.syncBundleProducts();
        },

        syncBundleProducts(){
            this.bundleProductRepository.sync(this.product.bundleProducts, Context.api);
        }

    }
});