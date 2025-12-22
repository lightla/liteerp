import api from "../common/api";

 const SupplierService = {
  add: (data) => api.post("/business-access/suppliers",data),
  update: (data) => api.put("/business-access/suppliers/" + data.id,data),
  show: (id) => api.get("/business-access/suppliers/" + id),
  list: ({
    keywords = '',
    page = 0,
    active = 1,
    order_by = ''
  }) => api.get("/business-access/suppliers" 
    + `?keywords=${keywords}&page=${page}
        &active=${active}&order_by=${order_by}`),
  delete: (data) => api.delete("/business-access/suppliers/" + data.id),
};
export default SupplierService;