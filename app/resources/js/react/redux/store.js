import { configureStore } from "@reduxjs/toolkit";
import themeReducer from "./themeSlice";
import businessReducer from './businessInfoSlice'
import notificationReducer from './NotificationSlice'
import purchasedetailReducer from './purchase/detailSlice'
export const store = configureStore({
  reducer: {
    theme: themeReducer,
    business: businessReducer,
    notify: notificationReducer,
    purchasedetail: purchasedetailReducer,
  },
});
