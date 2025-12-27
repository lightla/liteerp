import api from "../common/api";

 const CustomerService = {
  add: (data) => api.post("/business-access/customers",data),
  update: (data) => api.put("/business-access/customers/" + data.id,data),
  show: (id) => api.get("/business-access/customers/" + id),
  list: ({
    keywords = '',
    page = 0,
    type = '',
    order_by = '',
    active = 1
  }) => api.get("/business-access/customers" 
      + `?keywords=${keywords}&page=${page}&type=${type}
      &order_by=${order_by}&active=${active}`),
  delete: (data) => api.delete("/business-access/customers/" + data.id),
  view: () => api.get("/business-access/view/customers"),
};
export default CustomerService;