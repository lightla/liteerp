import React, { useCallback, useEffect, useState } from 'react';
import TabsCustom from '../TabsCustom';
import StockIns from './StockList/StockIns';
import StockOuts from './StockList/StockOuts';
import PageHead from '../PageHead';
export default function StockList() {
    return <div>
        <PageHead
              containerClass='mx-4'
              title='Stocks'
              subtitle='Manage warehouse receipts by business and import invoices'
              />
        <div className="m-4">
            <TabsCustom
                navs={[{ key: 'stockin', label: "Stock Ins" },
                { key: 'stockout', label: "Stock Outs" }]}
                contents={[
                    <StockIns/>,
                    <StockOuts/>
                ]} />
        </div>
    </div>
}
