import api from "../common/api";

 const ShippingService = {
  add: (data) => api.post("/business-access/shippings",data),
  update: (data) => api.put("/business-access/shippings/" + data.id,data),
  show: (data) => api.get("/business-access/shippings/" 
    + data.id + '?order_id=' 
    + data.order_id),
  list: ({
    page = 0,
    keywords = ''
  }) => api.get("/business-access/shippings?page=" + page 
    + '&keywords=' + keywords),
  delete: (data) => api.delete("/business-access/shippings/" + data.id),
};
export default ShippingService;