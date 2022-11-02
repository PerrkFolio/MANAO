import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { environment } from 'src/environments/environment';
import { Category } from '../models/category';
import { ResponseHttp } from '../models/responseHttp';
import { map,  catchError} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  
  getCategories() : Observable<Category[]> {
    return this.http.get<ResponseHttp>(environment.apiUrl + 'api/categories').pipe(
      map((data) => {
        return data.data.items;
      }),
      catchError((error) => {
        return throwError(error)
      })
    )
  }

  constructor(
    private http: HttpClient
  ) { }
}
