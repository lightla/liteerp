import api from "../common/api";

 const CustomerGroupService = {
  add: (data) => api.post("/business-access/customer-groups",data),
  update: (data) => api.put("/business-access/customer-groups/" + data.id,data),
  show: (id) => api.get("/business-access/customer-groups/" + id),
  list: ({
    page = 0,
    keywords = '',
    type = ''
  }) => api.get("/business-access/customer-groups" 
      + `?keywords=${keywords}&page=${page}&type=${type}`),
  delete: (data) => api.delete("/business-access/customer-groups/" + data.id),
};
export default CustomerGroupService;