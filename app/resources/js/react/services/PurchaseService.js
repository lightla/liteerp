import api from "../common/api";

 const PurchaseService = {
  add: (data) => api.post("/business-access/purchases",data),
  show: (id) => api.get("/business-access/purchases/" + id),
  list: ({
    keywords = '',
    page = 0,
    status = '',
    order_by = ''
  }) => api.get("/business-access/purchases" 
    + `?keywords=${keywords}&page=${page}&status=${status}&order_by=${order_by}`),
  update: (data) => api.put("/business-access/purchases/" + data.id,data)
};
export default PurchaseService;