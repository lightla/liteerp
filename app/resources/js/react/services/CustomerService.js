import api from "../common/api";

 const CustomerService = {
  add: (data) => api.post("/business-access/customers",data),
  update: (data) => api.put("/business-access/customers/" + data.id,data),
  show: (id) => api.get("/business-access/customers/" + id),
  list: (data) => api.get("/business-access/customers" + `?keywords=${data.keywords}&page=${data.page}&type=${data.type}`)
};
export default CustomerService;