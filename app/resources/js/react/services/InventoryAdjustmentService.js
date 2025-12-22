import api from "../common/api";

 const InventoryAdjustmentService = {
  list: ({
    page = 0,
    keywords = ''
  }) => api.get(`/business-access/inventory-adjustments?page=${page}&keywords=${keywords}`),
  add: (data) => api.post("/business-access/inventory-adjustments",data)
};
export default InventoryAdjustmentService;