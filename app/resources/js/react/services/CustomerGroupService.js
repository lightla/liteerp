import api from "../common/api";

 const CustomerGroupService = {
  add: (data) => api.post("/business-access/customer-groups",data),
  update: (data) => api.put("/business-access/customer-groups/" + data.id,data),
  show: (id) => api.get("/business-access/customer-groups/" + id),
  list: (data) => api.get("/business-access/customer-groups" 
      + `?keywords=${data.keywords}&page=${data.page}&type=${data.type}`),
  delete: (data) => api.delete("/business-access/customer-groups/" + data.id),
};
export default CustomerGroupService;