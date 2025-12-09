import { configureStore } from "@reduxjs/toolkit";
import themeReducer from "./themeSlice";
import businessReducer from './businessInfoSlice'
export const store = configureStore({
  reducer: {
    theme: themeReducer,
    business: businessReducer
  },
});
