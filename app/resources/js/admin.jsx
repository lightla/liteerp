import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { Provider } from "react-redux";
import { store } from "./react/redux/store";

// Pages
import Login from "./react/pages/login";
import Dashboard from "./react/pages/dashboard";
import Product from "./react/pages/product";
import Order from "./react/pages/order";
import Customer from "./react/pages/customer";
import Warehouse from "./react/pages/warehouse";
import Invoice from "./react/pages/invoice";
import Setting from "./react/pages/setting";
import User from "./react/pages/user";
import Register from "./react/pages/register";
import Business from "./react/pages/business";
import { PopupProvider } from "./react/components/popups/PopupContext";
import VerifyAccount from "./react/pages/verify-account";
import Membership from "./react/pages/membership";
import Notification from "./react/pages/notification";
import Stock from "./react/pages/stock";
import Purchases from "./react/pages/purchases";
import Suppliers from "./react/pages/suppliers";
import Shipping from "./react/pages/shipping";
import Inventory from "./react/pages/Inventory";
import ActivityLogs from "./react/pages/activity-logs";
import Profile from "./react/pages/Profile";
import ForgetPassword from "./react/pages/forget-password";
import ResetPassword from "./react/pages/reset-password";
import Logout from "./react/pages/Logout";
import Extensions from "./react/pages/Extensions";
import { I18nProvider } from "./i18n/I18nContext";
const App = () => {
  return (
      <Provider store={store}>
        <PopupProvider>
          <BrowserRouter basename="/dashboard">
            <Routes>
              <Route path="/" element={<Dashboard />} />
              <Route path="/login" element={<Login />} />
              <Route path="/register" element={<Register />} />
              <Route path="/verify-account" element={<VerifyAccount />} />
              <Route path="/products" element={<Product />} />
              <Route path="/orders" element={<Order />} />
              <Route path="/customers" element={<Customer />} />
              <Route path="/warehouses" element={<Warehouse />} />
              <Route path="/invoices" element={<Invoice />} />
              <Route path="/settings" element={<Setting />} />
              <Route path="/users" element={<User />} />
              <Route path="/business" element={<Business />} />
              <Route path="/membership" element={<Membership />} />
              <Route path="/notification" element={<Notification />} />
              <Route path="/stocks" element={<Stock />} />
              <Route path="/inventories" element={<Inventory />} />
              <Route path="/purchases" element={<Purchases />} />
              <Route path="/suppliers" element={<Suppliers />} />
              <Route path="/shippings" element={<Shipping />} />
              <Route path="/activity-logs" element={<ActivityLogs />} />
              <Route path="/profile" element={<Profile />} />
              <Route path="/forget-password" element={<ForgetPassword />} />
              <Route path="/reset-password" element={<ResetPassword />} />
              <Route path="/logout" element={<Logout />} />
              <Route path="/extensions" element={<Extensions />} />
            </Routes>
          </BrowserRouter>
        </PopupProvider>
      </Provider>  
  );
};

if (document.getElementById("app")) {
  ReactDOM.createRoot(document.getElementById("app")).render(
    <React.StrictMode>
      <I18nProvider>
        <App />
      </I18nProvider>
    </React.StrictMode>
  );
}
