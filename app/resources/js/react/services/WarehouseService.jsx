import api from "../common/api";

 const WarehouseService = {
  add: (data) => api.post("/business-access/warehouse",data),
  list: ({
    active = 1,
    keywords = '',
    page = 0
  }) => api.get("/business-access/warehouse?active=" 
    + active + '&keywords=' 
    + keywords + '&page=' + page),
  update: (data) => api.put("/business-access/warehouse/" + data.id,data),
  delete: (data) => api.delete("/business-access/warehouse/" + data.id)
};
export default WarehouseService;