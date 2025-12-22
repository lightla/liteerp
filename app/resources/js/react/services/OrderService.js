import api from "../common/api";

 const OrderService = {
  add: (data) => api.post("/business-access/orders",data),
  show: (id) => api.get("/business-access/orders/" + id),
  list: (data) => api.get("/business-access/orders" 
      + `?page=${data.page}&keywords=${data.keywords}&status=${data.status}&order_by=${data.order_by}`),
  update: (data) => api.put("/business-access/orders/" + data.id,data),
};
export default OrderService;