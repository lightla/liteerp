import api from "../common/api";

 const InventoryAdjustmentService = {
  list: (data) => api.get(`/business-access/inventory-adjustments?page=${data.page}&keywords=${data.keywords}`),
  add: (data) => api.post("/business-access/inventory-adjustments",data)
};
export default InventoryAdjustmentService;