import api from "../common/api";

 const PurchaseItemService = {
  add: (data) => api.post("/business-access/purchase-items",data),
  show: (id) => api.get("/business-access/purchase-items/" + id),
  list: ({
    page = 0,
    purchase_id = 0
  }) => api.get("/business-access/purchase-items" + `?page=${page}&purchase_id=${purchase_id}`),
  update: (data) => api.put("/business-access/purchase-items/" + data.id,data),
  delete: (data) => api.delete("/business-access/purchase-items/" + data.id)
};
export default PurchaseItemService;