import api from "../common/api";

 const ShippingService = {
  add: (data) => api.post("/business-access/shippings",data),
  update: (data) => api.put("/business-access/shippings/" + data.id,data),
  show: (data) => api.get("/business-access/shippings/" 
    + data.id + '?order_id=' 
    + data.order_id),
  list: (data) => api.get("/business-access/shippings?page=" + data.page + '&keywords=' + data.keywords)
};
export default ShippingService;