package com.clinic.clinic_app.service;

import com.clinic.clinic_app.model.Announcement;
import com.clinic.clinic_app.repository.AnnouncementRepository;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class AnnouncementService {

    private final AnnouncementRepository announcementRepository;

    public AnnouncementService(AnnouncementRepository announcementRepository) {
        this.announcementRepository = announcementRepository;
    }

    /**
     * Возвращает последние публичные объявления клиники.
     *
     * @return до трёх последних объявлений, отсортированных по дате публикации
     */
    public List<Announcement> findLatest() {
        return announcementRepository.findTop3ByOrderByPublishedAtDesc();
    }
}
