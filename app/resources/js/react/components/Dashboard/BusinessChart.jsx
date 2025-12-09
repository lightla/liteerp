import React from "react";
import {
  LineChart, Line, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid,
} from "recharts";
import { useSelector } from "react-redux";

const data = [
  { name: "January", sales: 4000, importCost: 1500, shippingCost: 900, netProfit: 1600, inventory: 1200 },
  { name: "February", sales: 3000, importCost: 1100, shippingCost: 700, netProfit: 1200, inventory: 1000 },
  { name: "March", sales: 5000, importCost: 1900, shippingCost: 700, netProfit: 2400, inventory: 900 },
  { name: "April", sales: 4780, importCost: 2100, shippingCost: 1000, netProfit: 1680, inventory: 850 },
  { name: "May", sales: 5890, importCost: 2200, shippingCost: 1000, netProfit: 2690, inventory: 950 },
  { name: "June", sales: 6390, importCost: 2500, shippingCost: 1400, netProfit: 2490, inventory: 880 },
  { name: "July", sales: 6490, importCost: 2600, shippingCost: 1500, netProfit: 2390, inventory: 920 },
  { name: "August", sales: 6590, importCost: 2400, shippingCost: 1400, netProfit: 2790, inventory: 890 },
  { name: "September", sales: 6690, importCost: 2100, shippingCost: 1400, netProfit: 3190, inventory: 860 },
  { name: "October", sales: 6790, importCost: 2400, shippingCost: 1800, netProfit: 2590, inventory: 870 },
  { name: "November", sales: 6890, importCost: 2500, shippingCost: 1700, netProfit: 2690, inventory: 890 },
  { name: "December", sales: 6990, importCost: 2300, shippingCost: 1800, netProfit: 2890, inventory: 910 },
];

export default function BusinessChart({
  title = "Business Chart",
}) {
  const theme = useSelector((state) => state.theme.mode);

  const isDark = theme === "dark-theme";
  const textColor = isDark ? "#e2e8f0" : "#162235";
  const gridColor = isDark ? "#162235" : "#cbd5e1";

  return (
    <div
      className="p-3 rounded-3 mt-4 BusinessChart"
      style={{
        backgroundColor: isDark ? "#162235" : "#fff",
        color: textColor,
      }}
    >
      <h5 className="mb-3">{title}</h5>
      <ResponsiveContainer width="100%" height={500}>
        <LineChart data={data}>
          <CartesianGrid strokeDasharray="3 3" stroke={gridColor} />
          <XAxis dataKey="name" stroke={textColor} />
          <YAxis stroke={textColor} />
          <Tooltip
            contentStyle={{
              backgroundColor: isDark ? "#1f2b3d" : "#f1f5f9",
              border: "none",
            }}
            labelStyle={{ color: textColor }}
          />

          <Line
            yAxisId="left"
            type="monotone"
            dataKey="sales"
            name="Sales"
            stroke="#22c55e"
            strokeWidth={3}
            dot={{ fill: "#22c55e" }}
          />

          <Line
            yAxisId="left"
            type="monotone"
            dataKey="importCost"
            name="Import Cost"
            stroke="#3b82f6"
            strokeWidth={2}
            dot={{ fill: "#3b82f6" }}
          />

          <Line
            yAxisId="left"
            type="monotone"
            dataKey="shippingCost"
            name="Shipping Cost"
            stroke="#a855f7"
            strokeWidth={2}
            dot={{ fill: "#a855f7" }}
          />

          <Line
            yAxisId="left"
            type="monotone"
            dataKey="netProfit"
            name="Net Profit"
            stroke="#eab308"
            strokeWidth={3}
            dot={{ fill: "#eab308" }}
          />

          <Line
            yAxisId="right"
            type="monotone"
            dataKey="inventory"
            name="Inventory"
            stroke="#60a5fa"
            strokeWidth={2}
            dot={{ fill: "#60a5fa" }}
          />
        </LineChart>
      </ResponsiveContainer>
    </div>
  );
}
