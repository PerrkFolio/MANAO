import { Category } from "./category";
import { Status } from "./status";

export interface Lead {
    id: number;
    link: string;
    is_express_delivery: boolean;
    comment : string;
    category_id: number;
    status_id: number;

    category?: Category;
    status?: Status;
}