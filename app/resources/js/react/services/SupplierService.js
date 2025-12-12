import api from "../common/api";

 const SupplierService = {
  add: (data) => api.post("/business-access/suppliers",data),
  update: (data) => api.put("/business-access/suppliers/" + data.id,data),
  show: (id) => api.get("/business-access/suppliers/" + id),
  list: (data) => api.get("/business-access/suppliers" 
    + `?keywords=${data.keywords}&page=${data.page}&active=${data.active}`),
  delete: (data) => api.delete("/business-access/suppliers/" + data.id),
};
export default SupplierService;