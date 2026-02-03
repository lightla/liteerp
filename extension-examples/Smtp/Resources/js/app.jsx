import React, { useState } from "react";
import { createRoot } from "react-dom/client";
import Home from "./components/Home";
import Wrappper from '@wrappers/Wrapper'
const App = () => {
  return <Wrappper>
    <Home />
  </Wrappper>
}

document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("extension-smtp");

  if (!container) return;

  const root = createRoot(container);
  root.render(<App />);
});
