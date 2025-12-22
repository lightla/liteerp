import api from "../common/api";

 const OrderService = {
  add: (data) => api.post("/business-access/orders",data),
  show: (id) => api.get("/business-access/orders/" + id),
  list: ({
    page = 0,
    keywords = '',
    status = '',
    order_by = ''
  }) => api.get("/business-access/orders" 
      + `?page=${page}&keywords=${keywords}
        &status=${status}&order_by=${order_by}`),
  update: (data) => api.put("/business-access/orders/" + data.id,data),
};
export default OrderService;