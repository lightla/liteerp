import React, { useCallback, useEffect, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import ListCustomer from '../components/Customer/ListCustomer'
import TabsCustom from '../components/TabsCustom'
import ListGroup from '../components/Customer/ListGroup'
import PageHead from '../components/PageHead'
export default function Customer() {
   
    return <DashboardLayout>
        <div>
            <PageHead
            containerClass='mx-4'
            title='Customers'
            subtitle='Manager customers'
            />
            <div className="m-4">
                <TabsCustom
                navs={[
                    {key: 'customer',label: 'Customer'},
                    {key: 'group', label: 'Group'}
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