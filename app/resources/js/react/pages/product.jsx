import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import TabsCommon from '../components/TabsCustom';
import Category from '../components/Product/Category';
import ListProducts from '../components/Product/ListProducts';
import PriceList from '../components/Product/PriceList';
import PageHead from '../components/PageHead';
export default function Product() {

    return <DashboardLayout>
        <div>
            <PageHead
                title='Products'
                subtitle='Manager product by warehouse, category'
                />
            <div className="container mt-3">
                <TabsCommon navs={[{
                    key: 'products',
                    label: 'Products'
                }, {
                    key: 'category',
                    label: 'Category'
                }, {
                    key: 'price',
                    label: 'Price list'
                }]}
                    contents={[<div>
                        <ListProducts />
                    </div>, <div>
                        <Category />
                    </div>, <div>
                        <PriceList />
                    </div>]}
                />
            </div>
        </div>
    </DashboardLayout>
}