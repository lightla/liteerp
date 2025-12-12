import api from "../common/api";

 const WarehouseService = {
  add: (data) => api.post("/business-access/warehouse",data),
  list: (data) => api.get("/business-access/warehouse?active=" 
    + (data.active ?? 1) + '&keywords=' 
    + data.keywords + '&page=' + data.page),
  update: (data) => api.put("/business-access/warehouse/" + data.id,data),
  delete: (data) => api.delete("/business-access/warehouse/" + data.id)
};
export default WarehouseService;