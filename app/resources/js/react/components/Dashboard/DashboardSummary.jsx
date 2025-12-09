import React from "react";
import { CurrencyDollar, Cart, People, BoxArrowUp } from "react-bootstrap-icons";

const summaryData = [
  {
    title: "Total Revenue",
    value: "2,450,000",
    change: "+12.5%",
    note: "compared to last month",
    icon: <CurrencyDollar size={20} color="#0ea5e9" />,
    iconBg: "#0ea5e933",
  },
  {
    title: "Total Orders",
    value: "1,847",
    change: "+8.3%",
    note: "compared to last month",
    icon: <Cart size={20} color="#2563eb" />,
    iconBg: "#2563eb33",
  },
  {
    title: "Total Customers",
    value: "12,456",
    change: "+15.2%",
    note: "compared to last month",
    icon: <People size={20} color="#9333ea" />,
    iconBg: "#9333ea33",
  },
  {
    title: "Total Products",
    value: "3,892",
    change: "+5.7%",
    note: "compared to last month",
    icon: <BoxArrowUp size={20} color="#f59e0b" />,
    iconBg: "#f59e0b33",
  },
];

export default function DashboardSummary() {
  return (
    <div className="erp-summary-container d-flex flex-wrap gap-3 mt-3">
      {summaryData.map((item, i) => (
        <div key={i} className="erp-summary-card flex-grow-1 p-3">
          <div className="d-flex justify-content-between align-items-start">
            <div>
              <p className="erp-summary-title mb-1">{item.title}</p>
              <h4 className="erp-summary-value mb-2">{item.value}</h4>
            </div>
            <div
              className="erp-summary-icon rounded-3 d-flex align-items-center justify-content-center"
              style={{ backgroundColor: item.iconBg }}
            >
              {item.icon}
            </div>
          </div>
          <div className="mt-2">
            <span className="erp-summary-change">{item.change}</span>{" "}
            <small className="text-secondary">{item.note}</small>
          </div>
        </div>
      ))}
    </div>
  );
}
