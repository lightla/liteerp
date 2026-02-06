import React, { useState } from "react";
import { createRoot } from "react-dom/client";
import Home from "./components/Home";
import DashboardLayout from '@layouts/DashboardLayout'
const App = () => {
  return <DashboardLayout>
    <Home />
  </DashboardLayout>
}
export default App;