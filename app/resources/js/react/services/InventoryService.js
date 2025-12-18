import api from "../common/api";

const InventoryService = {
    add: (data) => api.post("/business-access/inventory", data),
    show: (id) => api.get("/business-access/inventory/" + id),
    list: (data) => api.get("/business-access/inventory"
         + `?page=${data.page}&keywords=${data.keywords}${data?.customer_group_id 
                ? '&customer_group_id=' + data.customer_group_id : ''}`),
    update: (data) => api.put("/business-access/inventory/" + data.id, data),
};
export default InventoryService;