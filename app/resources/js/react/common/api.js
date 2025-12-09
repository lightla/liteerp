import axios from "axios";
import { store } from "../redux/store";

// 👇 Tạo instance axios
const api = axios.create({
  baseURL: "/api", // Laravel API route prefix
  timeout: 10000,
  headers: {
    "Content-Type": "application/json",
  },
});

// 🧠 Request Interceptor
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    const businessToken = localStorage.getItem("business-access");
    if (token) config.headers.Authorization = `Bearer ${token}`;
    if(businessToken) config.headers['business-access'] = businessToken;
    return config;
  },
  (error) => Promise.reject(error)
);

// ⚡ Response Interceptor
api.interceptors.response.use(
  (response) => response.data,
  (error) => {
    const status = error.response?.status;
    if (status === 401) {
      console.warn("Token hết hạn, đăng xuất...");
      localStorage.removeItem("token");
      // Reload hoặc chuyển hướng về login
      window.location.href = "/dashboard/login";
    }

    console.error("API Error:", error.response?.data || error.message);
    return Promise.reject(error);
  }
);

export default api;
