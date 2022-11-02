import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { ResponseHttp } from '../models/responseHttp';
import { Status } from '../models/status';

@Injectable({
  providedIn: 'root'
})
export class StatusService {
  getStatuses() : Observable<Status[]> {
    return this.http.get<ResponseHttp>(environment.apiUrl + 'api/statuses').pipe(
      map((data) => {
        return data.data.items;
      }),
      catchError((error) => {
        return throwError(error)
      })
    )
  }

  constructor(private http: HttpClient) { }
}
