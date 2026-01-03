import React from "react";
import DashboardLayout from "../layouts/DashboardLayout";
import TabsCommon from '../components/TabsCustom'
import InvoiceIns from "../components/Invoice/InvoiceIns";
import InvoiceOuts from "../components/Invoice/InvoiceOuts";
import { useSearchParams } from "react-router-dom";
import InvoiceInDetail from "../components/Invoice/InvoiceIns/InvoiceInDetail";
import InvoiceOutDetail from "../components/Invoice/InvoiceOuts/InvoiceOutsDetail";
import PageHead from "../components/PageHead";
import CustomInvoiceOuts from "../components/Invoice/CustomInvoiceOuts";
import CustomInvoiceIns from "../components/Invoice/CustomInvoiceIns";
export default function Invoice() {
  const [searchParams] = useSearchParams();
  return (
    <DashboardLayout>
      {searchParams.get('form') && searchParams.get('id') ? <div>
        {searchParams.get('form') === 'invoicein' ? <InvoiceInDetail/> : null}
        {searchParams.get('form') === 'invoiceout' ? <InvoiceOutDetail/> : null}
      </div> : <div>
        <PageHead
                      containerClass='mx-4'
                      title='Invoices'
                      subtitle='List of invoices and accounting details'
                      />
        <div className="m-4">

          <TabsCommon navs={[
            { key: 'InvoiceIn', label: 'Invoice Ins' },
            { key: 'InvoiceOut', label: 'Invoice Outs' },
            { key: 'CustomInvoiceOut', label: 'Custom Invoice Outs' },
            { key: 'CustomInvoiceIn', label: 'Custom Invoice Ins' }
          ]} contents={[<InvoiceIns />,
            <InvoiceOuts />,
            <CustomInvoiceOuts />,
            <CustomInvoiceIns/>
          ]} />

        </div>
      </div> }
      
    </DashboardLayout>
  );
}
