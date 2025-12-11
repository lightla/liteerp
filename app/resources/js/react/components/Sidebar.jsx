import React from "react";
import {
  HouseDoor,
  Cart,
  Box,
  People,
  FiletypeDocx,
  BarChart,
  BuildingGear,
  Diagram2,
  CurrencyDollar,
  Building
} from "react-bootstrap-icons";
import { useSelector } from "react-redux";
import { NavLink } from "react-router-dom";

export default function Sidebar() {
  const business = useSelector((state) => state.business.data);
  return (
    <div className="erp-sidebar d-flex flex-column p-3 px-5">
      {/* Header */}
      <div className="d-flex align-items-center mb-4">
        <div className="erp-logo rounded-3 d-flex align-items-center justify-content-center me-2">
          <HouseDoor size={20} color="#fff" />
        </div>
        <div>
          <h5 className="mb-0 fw-bold erp-sidebar-title">LiteERP</h5>
          <small className="theme-title">Simple and Pure</small>
        </div>
      </div>

      {/* Menu */}
      <ul className="nav nav-pills flex-column mb-auto">
        {business?.role === 'admin' || business?.role === 'accountanter'
        || business?.role === 'manager' ? <li className="nav-item mb-2">
          <NavLink to="/" className="erp-link">
            <BarChart className="me-2" /> Overview
          </NavLink>
        </li> : null}
        {business?.role === 'admin' || business?.role === 'manager'
        || business?.role === 'purchaser' ?  
        <li className="nav-item mb-2">
          <NavLink to="/purchases" className="erp-link">
            <CurrencyDollar className="me-2" /> Purchases
          </NavLink>
        </li> : null}
        {business?.role === 'admin' || business?.role === 'seller'
        || business?.role === 'manager' ?   
        <li className="nav-item mb-2">
          <NavLink to="/orders" className="erp-link">
            <Cart className="me-2" /> Orders
          </NavLink>
          
        </li> : null}
        <li className="nav-item mb-2">
          <NavLink to="/products" className="erp-link">
            <Box className="me-2" /> Products
          </NavLink>
        </li>
        {business?.role === 'admin' || business?.role === 'purchaser'
        || business?.role === 'manager' ?   
        <li className="nav-item mb-2">
          <NavLink to="/suppliers" className="erp-link">
            <People className="me-2" /> Suppliers
          </NavLink>
        </li> : null}
        {business?.role === 'admin' || business?.role === 'seller'
        || business?.role === 'manager' ?
        <li className="nav-item mb-2">
          <NavLink to="/customers" className="erp-link">
            <People className="me-2" /> Customers
          </NavLink>
        </li> : null}
        {business?.role === 'admin' || business?.role === 'warehouseman'
        || business?.role === 'manager' ?
        <li className="nav-item mb-2">
          <NavLink to="/warehouses" className="erp-link">
            <Building className="me-2" /> Warehouses
          </NavLink>
        </li> : null}
        {business?.role === 'admin' || business?.role === 'warehouseman'
        || business?.role === 'manager' ?
        <li className="nav-item mb-2">
          <NavLink to="/stocks" className="erp-link">
            <FiletypeDocx className="me-2" /> Stocks
          </NavLink>
        </li> : null}
          {business?.role === 'admin' || business?.role === 'warehouseman'
        || business?.role === 'manager' ?
        <li className="nav-item mb-2">
          <NavLink to="/inventories" className="erp-link">
            <FiletypeDocx className="me-2" /> Inventories
          </NavLink>
        </li> : null}
        {business?.role === 'admin' || business?.role === 'accountanter'
        || business?.role === 'manager' ?
        <li className="nav-item mb-2">
          <NavLink to="/invoices" className="erp-link">
            <FiletypeDocx className="me-2" /> Invoices
          </NavLink>
        </li> : null}
        {business?.role === 'admin' || business?.role === 'warehouseman'
        || business?.role === 'manager' ?
        <li className="nav-item mb-2">
          <NavLink to="/shippings" className="erp-link">
            <FiletypeDocx className="me-2" /> Shipping Providers
          </NavLink>
        </li> : null}
          {business?.role === 'admin' ?
        <li className="nav-item mb-2">
          <NavLink to="/settings" className="erp-link">
            <BuildingGear className="me-2" /> Settings
          </NavLink>
        </li> : null}
        {business.role === 'admin' ? <li className="nav-item mb-2">
          <NavLink to="/users" className="erp-link">
            <People className="me-2" /> Employees
          </NavLink>
        </li> : null }
        {business?.role === 'admin'
        || business?.role === 'manager' ?
        <li className="nav-item mb-2">
          <NavLink to="/activity-logs" className="erp-link">
            <Diagram2 className="me-2" /> Logs
          </NavLink>
        </li> : null}
      </ul>
    </div>
  );
}
