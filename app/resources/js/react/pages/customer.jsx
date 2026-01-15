import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import ListCustomer from '../components/Customer/ListCustomer'
import TabsCustom from '../components/TabsCustom'
import ListGroup from '../components/Customer/ListGroup'
import PageHead from '../components/PageHead'
import { useI18n } from '../../i18n/useI18n'
export default function Customer() {
   const {t} = useI18n();
    return <DashboardLayout>
        <div>
            <PageHead
            containerClass='mx-4'
            title='Customers'
            subtitle="page_customer_desc"
            />
            <div className="m-4">
                <TabsCustom
                navs={[
                    {key: 'customer',label: t('Customer')},
                    {key: 'group', label: t('Group')}
                ]}
                contents={[
                    <div className='mt-1'>
                        <ListCustomer/>
                    </div>,
                    <div className='mt-1'>
                        <ListGroup/>
                    </div>
                ]}
                />
            </div>
        </div>
    </DashboardLayout>
}